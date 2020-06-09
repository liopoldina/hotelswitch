#!C:/Users/Pedro/AppData/Local/Programs/Python/Python38/python.exe
import json
from bs4 import BeautifulSoup
import requests


# headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/602.2.14 (KHTML, like Gecko) Version/10.0.1 Safari/602.2.14',}
# source = requests.get('https://es.hoteles.com/search.do?destination-id=1506246', headers=headers).text

# fields
currency = "cur=EUR"
destination_id = "&destination-id=1506246"
destination = "&q-destination=New York"
check_in = "&q-check-in=2020-06-10"
check_out = "&q-check-out=2020-06-11"
rooms = "&q-rooms=1"
stars = "&f-star-rating=5,4,3,2,1"
property_type_hotels = "&f-accid=1"

search_term = currency + destination_id + check_in + \
    check_out + rooms + stars + property_type_hotels

url = "https://uk.hotels.com/search.do?" + search_term

print(url)

source = requests.get(url).text

soup = BeautifulSoup(source, 'lxml')

sections = soup.find_all('section', class_='hotel-wrap')


class Hotel:

    def function(self):
        pass


hotels = []
for i in range(0, len(sections)):

    section = sections[i]

    hotels.append(Hotel())
    # name
    hotels[i].name = section.find('a', class_='property-name-link').text

    # stars
    hotels[i].stars = int(section.find(
        'span', class_='star-rating-text').text[:1])

    # score
    hotels[i].score = section.find(
        'strong', class_='guest-reviews-badge').text[-3:]
    hotels[i].score = float(hotels[i].score.replace(',', '.'))

    # number of reviews
    hotels[i].nr_reviews = section.find('span', class_='small-view').text
    hotels[i].nr_reviews = hotels[i].nr_reviews.split()[0]

    # city
    hotels[i].city = soup.find('h1', class_='destination-title').text
    hotels[i].city = hotels[i].city.split(',')[0]

    # district
    hotels[i].district = section.find('a', class_='map-link').text

    # distance center
    hotels[i].distance_center = section.find(
        'ul', class_='property-landmarks').text[:3]

    # room name
    hotels[i].room_name = "Double Room"

    # bed type
    hotels[i].room_bed_type = "1 Double Bed"

    # cancellation policy
    hotels[i].room_cancellation_policy = ""
    if section.find('li', class_='deals-item') is not None:
        hotels[i].room_cancellation_policy = section.find(
            'li', class_='deals-item').text

    # payment policy
    hotels[i].room_payment_policy = ""

    # price
    if section.find('div', class_='price').ins is not None:
        hotels[i].price = section.find('div', class_='price').ins.text

    if section.find('div', class_='price').strong is not None:
        hotels[i].price = section.find('div', class_='price').strong.text

with open('temp/hotels.json', 'w') as outfile:
    json.dump([ob.__dict__ for ob in hotels], outfile)
