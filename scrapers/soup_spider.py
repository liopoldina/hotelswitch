#!C:/Users/Pedro/AppData/Local/Programs/Python/Python38/python.exe
import json
from bs4 import BeautifulSoup
import requests

source = requests.get(
    'https://www.hotels.com/search.do?destination-id=1506246').text

soup = BeautifulSoup(source, 'lxml')

sections = soup.find_all('section', class_='hotel-wrap')


class Hotel:

    def function(self):
        pass


hotels = []
for i in range(0, len(sections)):

    section = sections[i]

    hotels.append(Hotel())

    hotels[i].name = section.find('a', class_='property-name-link').text
    hotels[i].stars = 4
    hotels[i].score = 9.4
    hotels[i].nr_reviews = 1400
    hotels[i].city = "Lisbon"
    hotels[i].district = "Misericordia"
    hotels[i].distance_center = "0.5 km"
    hotels[i].room_name = "Double Room"
    hotels[i].room_bed_type = "1 Double Bed"
    hotels[i].room_cancellation_policy = "Free cancellation"
    hotels[i].room_payment_policy = "Prepayment needed"

    if section.find('div', class_='price').ins is not None:
        hotels[i].price = section.find('div', class_='price').ins.text

    if section.find('div', class_='price').strong is not None:
        hotels[i].price = section.find('div', class_='price').strong.text

with open('temp/hotels.json', 'w') as outfile:
    json.dump([ob.__dict__ for ob in hotels], outfile)
