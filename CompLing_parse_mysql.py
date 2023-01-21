import re                       # regular expressions lib
import requests                 # site reading lib
import pymysql
from bs4 import BeautifulSoup   # parsing lib
from datetime import date, timedelta
from config_mysql import host, user, password, db_name


def parser(url):
    basic_url = 'https://bloknot-volgograd.ru'
    r = requests.get(url)

    soup = BeautifulSoup(r.text, 'html.parser')
    names, links, dates, texts = [], [], [], []

    # get clean names and links
    all_text = soup.find_all(class_='sys', limit=10)
    for c in all_text:
        names.append(c.text)
        if re.match(r'https:', c['href']):
            links.append(c['href'] + '/1553047/')
        else:
            links.append(basic_url + c['href'])

    # get clean dates
    all_dates = soup.find_all(string=[re.compile(r'сегодня в'), re.compile(r'вчера в'), re.compile(r'\.20')], limit=16)
    skip = 0
    for c in all_dates:
        if skip < 5:
            skip += 1
            continue
        if c.text.__contains__('сегодня'):
            dates.append(date.today().strftime("%d.%m.%Y"))
        elif c.text.__contains__('вчера'):
            dates.append((date.today() - timedelta(days=1)).strftime("%d.%m.%Y"))
        else:
            dates.append(re.sub('\t|\n|\xa0| ', '', c.text))

    # get clean texts
    for c in links:
        # убираем лишние переносы табуляции, заменяем на нормальные
        clipped_text = re.sub('\t', '\n\n\t', re.sub("\n|\xa0|\r|[0-9]+ Новости на Блoкнoт-Волгоград", ' ', text_parser(c)))
        # убираем лишние пробелы
        clean_text = re.sub(" +", " ", clipped_text)
        texts.append(clean_text)

    db_input(names, dates, links, texts)


def text_parser(url):
    try:
        r = requests.get(url)
    except requests.exceptions.TooManyRedirects:
        print("Page ", url, " has been passed")
        return "Passed"
    soup = BeautifulSoup(r.text, 'html.parser')
    text = ''
    all_text = soup.find_all(class_='news-text')
    for c in all_text:
        text += c.text
    all_text = soup.find_all(class_='guide_right bars')
    for c in all_text:
        text += c.text
    return text


def db_input(name, date, link, text):
    # Подключаемся к MySQL
    connection = pymysql.connect(host=host, user=user, password=password, database=db_name)
    for i in range(len(name)):
        with connection.cursor() as cursor:
            connection.autocommit = True
            cursor.execute("""INSERT INTO aboba.news (name, date, link, text) VALUES (%s, %s, %s, %s);""",
                           (name[i], date[i], link[i], text[i]))
            connection.commit()
            cursor.close()


def main():
    url = 'https://bloknot-volgograd.ru/?PAGEN_1='
    num_of_pages = int(input('How many pages you want to parse: '))
    start_page = int(input('Where to start?: '))
    # Parsing site
    for c in range(start_page, start_page+num_of_pages-1):
        parser(url+str(c))
        print('Page ', c, ' loaded')
    print('Parsing finished')


main()
