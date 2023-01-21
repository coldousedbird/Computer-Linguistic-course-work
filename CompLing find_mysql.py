import re                       # regular expressions lib
import requests                 # site reading lib
import pymysql
from bs4 import BeautifulSoup   # parsing lib
from datetime import date, timedelta
from config_mysql import host, user, password, db_name


def db_output_news_num():
    # Подключаемся к MySQL
    connection = pymysql.connect(host=host, user=user, password=password, database=db_name)
    with connection.cursor() as cursor:
        cursor.execute("SELECT count(*) FROM `news`;")
        result = cursor.fetchall()[0][0]
        cursor.close()
    return result


def db_output(id_news):
    # Подключаемся к MySQL
    connection = pymysql.connect(host=host, user=user, password=password, database=db_name)
    with connection.cursor() as cursor:
        query = "SELECT name, text FROM `aboba`.`news` WHERE id = %d"
        cursor.execute(query % id_news)
        result = cursor.fetchall()[0]
        cursor.close()
        return result


def mentions_persons_analyze(news_id, title, text):
    persons = [
    # это кортеж из кортежей
    # 1 - полное ФИО, 2 - формы фамилии, 3 - формы имён, 4 - формы отчеств
    ['Бочаров Андрей Иванович',
     ['Бочаров', 'Бочарова', 'Бочарову', 'Бочарова', 'Бочаровым', 'Бочарове'],
     ['Андрей', 'Андрея', 'Андрею', 'Андрея', 'Андреем', 'Андрее'],
     ['Иванович', 'Ивановича', 'Ивановичу', 'Ивановича', 'Ивановичем', 'Ивановиче']],
    ['Прошаков Андрей Павлович',
     ['Прошаков', 'Прошакова', 'Прошакову', 'Прошакова', 'Прошаковым', 'Прошакове'],
     ['Андрей', 'Андрея', 'Андрею', 'Андрея', 'Андреем', 'Андрее'],
     ['Павлович', 'Павловича', 'Павловичу', 'Павловича', 'Павловичем', 'Павловиче']],
    ['Писемская Анна Сергеевна',
     ['Писемская', 'Писемской', 'Писемской', 'Писемскую', 'Писемской', 'Писемской'],
     ['Анна', 'Анны', 'Анне', 'Анну', 'Анной', 'Анне'],
     ['Сергеевна', 'Сергеевны', 'Сергеевне', 'Сергеевну', 'Сергеевной', 'Сергеевне']],
    ['Марченко Владимир Васильевич',
     ['Марченко', 'Марченко', 'Марченко', 'Марченко', 'Марченко', 'Марченко'],
     ['Владимир', 'Владимира', 'Владимиру', 'Владимира', 'Владимиром', 'Владимире'],
     ['Васильевич', 'Васильевича', 'Васильевичу', 'Васильевича', 'Васильевичем', 'Васильевиче']],
    ['Бельских Игорь Евгеньевич',
     ['Бельских', 'Бельских', 'Бельских', 'Бельских', 'Бельских', 'Бельских'],
     ['Игорь', 'Игоря', 'Игорю', 'Игоря', 'Игорем', 'Игоре'],
     ['Евгеньевич', 'Евгеньевича', 'Евгеньевичу', 'Евгеньевича', 'Евгеньевичем', 'Евгеньевиче']],
    ]
    # persons[Person 0-4][Ф/И/О - 1/2/3][Склонение 1-6] | persons[i][0] - Full name of i-person
    text = title+'\n'+text
    for i in range(len(persons)):
        text_contains_mention = False
        # check for any mentions of this surname
        for y in range(6):
            if persons[i][1][y] in text:
                text_contains_mention = True
                break
        # count for any mentions of this person
        if text_contains_mention:
            mentions_num = 0
            for y in range(6):
                mentions_num += text.count(persons[i][1][y] + ' ' + persons[i][2][y])
                mentions_num += text.count(persons[i][2][y] + ' ' + persons[i][1][y])
                mentions_num += text.count(persons[i][2][y] + ' ' + persons[i][3][y])
                if mentions_num == 0:
                    mentions_num += text.count(persons[i][1][y])
            print("'", title, "' contains ", persons[i][1][y], ' ', mentions_num, ' times')
            db_input_mention(news_id, persons[i][0], str(mentions_num))


def mentions_sights_analyze(news_id, title, text):
    sights = [
    ['Волгоград Арена', 'Волгоград Арены', 'Волгоград Арене', 'Волгоград Арену', 'Волгоград Ареной'],
    ['Старая Сарепта', 'Старой Сарепты', 'Старой Сарепте', 'Старую Сарепту', 'Старой Сарептой'],
    ['музей Машкова', 'музея Машкова', 'музею Машкова', 'музей Машкова', 'музеем Машкова', 'музее Машкова'],
    ['библиотека Горького', 'библиотеки Горького', 'библиотеке Горького', 'библиотеку Горького', 'библиотекой Горького'],
    ['Памятник Дзержинскому', 'Памятника Дзержинскому', 'Памятнику Дзержинскому', 'Памятником Дзержинского', 'Памятнике Дзержинскому']
    ]
    sights_full_name = [
        'Стадион "Волгоград Арена"',
        'Музей-заповедник "Старая Сарепта"',
        'Волгоградский музей изобразительных искусств им. И.И. Машкова',
        'Областная универсальная научная библиотека им. М. Горького',
        'Памятник Дзержинскому'
    ]
    text = title+'\n'+text
    for i in range(len(sights)):
        mentions_num = 0
        for y in range(len(sights[i])):
            mentions_num += text.count(sights[i][y])
        if not mentions_num == 0:
            print(sights_full_name[i], ' detected in ', news_id, ' article ', mentions_num, ' times')
            db_input_mention(news_id, sights_full_name[i], str(mentions_num))


def db_input_mention(id_news_has_mentions, persons_name, number_of_mentions):
    # Подключаемся к MySQL
    connection = pymysql.connect(host=host, user=user, password=password, database=db_name)
    with connection.cursor() as cursor:
        connection.autocommit = True
        query = "INSERT INTO mentions (id_news_has_mentions, FIO, number_of_mentions) VALUES (%d, '%s', %s);"
        cursor.execute(query % (id_news_has_mentions, persons_name, number_of_mentions))
        connection.commit()
        cursor.close()


def main():
    num_of_news = db_output_news_num()
    print('News amount: ', num_of_news)
    print('1 - parse persons, 2 - parse sights')
    boba = int(input('What do you choose?: '))

    # Parsing site
    for i in range(1, num_of_news):
        article = db_output(i)
        # print('i = ', i, ', art = ', article)
        if boba == 1:
            mentions_persons_analyze(i, article[0], article[1])
        else:
            mentions_sights_analyze(i, article[0], article[1])

main()
