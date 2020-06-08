#!C:/Users/Pedro/AppData/Local/Programs/Python/Python38/python.exe
import json
import scrapy
from scrapy.crawler import CrawlerProcess


class items(scrapy.Item):
    # define the fields for your item here like:
    name = scrapy.Field()
    price = scrapy.Field()
    pass


global hotel_item
hotel_item = items()


class hotelSpider (scrapy.Spider):
    name = 'hotel'
    start_urls = [
        'https://es.hoteles.com/search.do?destination-id=1506246']

    def parse(self, response):

        hotel_item['name'] = response.css(
            "a.property-name-link::text").extract()
        hotel_item['price'] = response.xpath(
            '//div[@class="price"]/strong/text() | //div[@class="price"]/ins/text()').extract()


process = CrawlerProcess({
    # 'USER_AGENT': 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)'
})

process.crawl(hotelSpider)
process.start()


class Hotel:

    def function(self):
        pass


hotels = []
for i in range(0, len(hotel_item['name'])):
    hotels.append(Hotel())
    hotels[i].name = hotel_item['name'][i]
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
    hotels[i].price = hotel_item['price'][i]

with open('temp/hotels.json', 'w') as outfile:
    json.dump([ob.__dict__ for ob in hotels], outfile)
