import json
import csv
import random

Article_Journal_Collections = {"Article": ''}
Article_mongo_list = []

magazine_check_list = []
author_check_list = []


def main():
    # initialize variables
    url_path = '/home/course/cda540/u05/DBProject/articles.json'

    # Output csv files
    Author = '/home/course/cda540/u05/DBProject/Author.tsv'
    Article = '/home/course/cda540/u05/DBProject/Article.tsv'
    Magazine = '/home/course/cda540/u05/DBProject/Magazine.tsv'
    MagazineVolume = '/home/course/cda540/u05/DBProject/MagazineVolume.tsv'
    ArticleAuthor = '/home/course/cda540/u05/DBProject/ArticleAuthor.tsv'

    article_author_file = open(ArticleAuthor, 'w')
    csv_article_author_writer = csv.writer(article_author_file, delimiter="\t")
    csv_article_author_writer.writerow(["article_id", "author_id"])

    from random import randint

    for i in range(1, 74520):
        csv_article_author_writer.writerow([i, randint(0, 140000)])

    article_author_file.close()

    author_file = open(Author, 'w')
    csv_author_writer = csv.writer(author_file, delimiter="\t")
    csv_author_writer.writerow(["_id, lname", "fname", "email"])

    article_file = open(Article, 'w')
    csv_article_writer = csv.writer(article_file, delimiter="\t")
    csv_article_writer.writerow(["_id", "volumeNumber", "title", "pages"])

    magazine_file = open(Magazine, 'w')
    csv_magazine_writer = csv.writer(magazine_file, delimiter="\t")
    csv_magazine_writer.writerow(["_id", "name"])

    magazineVolume_file = open(MagazineVolume, 'w')
    csv_magazineVolume_writer = csv.writer(magazineVolume_file, delimiter="\t")
    csv_magazineVolume_writer.writerow(["_id", "volumeNumber", "year"])

    # get data from Article JSON
    data = open(url_path, 'r')

    articleId = 1
    magazineId = 4

    for everyAuthor in data.readlines():
        try:

            everyAuthor = json.loads(everyAuthor)
            author = everyAuthor['author']
            checkAuthor = type(author)
            if checkAuthor is list:
                authorName = '['
                for multipleAuthors in author:
                    fname, lname, email = nameManipulation(str(multipleAuthors['ftext']))
                    try:
                        email.encode('ascii')
                        if email not in author_check_list:
                            csv_author_writer.writerow(["NULL", lname, fname, email])
                            author_check_list.append(email)
                            authorName = str(authorName + '|' + str(multipleAuthors['ftext']))
                    except UnicodeDecodeError:
                        pass
                author = authorName + ']'
            else:
                author = str(everyAuthor['author']['ftext'])
                fname, lname, email = nameManipulation(author)

                try:
                    email.encode('ascii')
                    if email not in author_check_list:
                        csv_author_writer.writerow(["NULL", lname, fname, email])
                        author_check_list.append(email)
                except UnicodeDecodeError:
                    pass
                "file.py contains non-ascii characters"

            articleTitle = str(everyAuthor['title']['ftext'])
            pages = str(everyAuthor['pages']['ftext'])
            year = str(everyAuthor['year']['ftext'])
            volumeNumber = str(everyAuthor['volume']['ftext'])
            journalName = str(everyAuthor['journal']['ftext'])

            Article_mongo_list.append(
                dict(zip(["_id", "Authors", "Article title", "Journal name", "Volume number", "Pages", "Year"],
                         [articleId, author, articleTitle, journalName, volumeNumber, pages, year])))

            try:
                articleTitle.encode('ascii')
                if volumeNumber not in ['2010', '2011', '2012', '2013', '2014', '2015', '43-44']:
                    if not pages.__contains__('2018'):
                        csv_article_writer.writerow([articleId, volumeNumber, articleTitle, pages])
            except UnicodeDecodeError:
                pass

            if journalName not in magazine_check_list:
                csv_magazine_writer.writerow([magazineId, journalName])
                magazine_check_list.append(journalName)
            	csv_magazineVolume_writer.writerow([magazineId, volumeNumber, year])
		magazineId += 1
            articleId += 1


        except Exception as e:
            e = e.args
            if (e == ('pages',)) or (e == ('author',)):
                pass
            else:
                pass

    # Close all the CSV files
    author_file.close()
    article_file.close()
    magazine_file.close()
    magazineVolume_file.close()

    Article_Journal_Collections['Article'] = Article_mongo_list
    with open('/home/course/cda540/u05/DBProject/articles_mongo.json', 'w') as jsonFile:
        json.dump(Article_Journal_Collections['Article'], jsonFile)


def nameManipulation(fullName):
    emailDomains = ['@gmail.com', '@ymail.com', '@smu.ca', '@hotmail.edu', '@dkg.com']
    check = False
    fname = ''
    lname = ''
    for names in fullName.split():
        if (check):
            lname = lname + names + ' '
        else:
            fname = names
        check = True

    email = fname + '.' + lname.replace(' ', '_') + random.choice(emailDomains)

    return fname, lname, email



if __name__ == "__main__":
    main()
