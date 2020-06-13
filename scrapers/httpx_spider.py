#!C:/Users/Pedro/AppData/Local/Programs/Python/Python38/python.exe
import json
from bs4 import BeautifulSoup
import re
import sys
import httpx


# fields
# check_in = sys.argv[1]
# check_out = sys.argv[2]
# destination_name = sys.argv[3]

# if len(sys.argv) == 5:
#     destination_id = sys.argv[4]
# else:
#     destination_id = ""

class parameters:
    pass


param = parameters()

param.check_in = "2020-07-10"
param.check_out = "2020-07-11"
param.destination_name = "Lisbon"
param.destination_id = "1063515"

# search_url = "https://uk.hotels.com/search.do?"

listings_url = "https://uk.hotels.com/search/listings.json"

# search_parameters = {
#     "currency": "cur=EUR",
#     "q-destination": param.destination_name,
#     "destination-id": param.destination_id,
#     "q-check-in": param.check_in,
#     "q-check-out": param.check_out,
#     "q-rooms": 1,
#     "f-star-rating": "5,4,3,2,1",
#     "f-accid": 1
# }


# search_headers = {
#     "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
#     "accept-encoding": "gzip, deflate, br",
#     "accept-language": "en-US,en;q=0.9,pt;q=0.8",
#     "cache-control": "no-cache",
#     "pragma": "no-cache",
#     "referer": "https://uk.hotels.com/",
#     "sec-fetch-dest": "document",
#     "sec-fetch-mode": "navigate",
#     "sec-fetch-site": "same-origin",
#     "sec-fetch-user": "?1",
#     "upgrade-insecure-requests": "1",
#     "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.3"
# }

# star session and get search page to get 1st page and cookies
# s = requests.Session()
# s.headers = search_headers
# search_page = s.get(search_url, params=search_parameters)

listings_parameters = {
    "q-destination": param.destination_name,
    "destination-id": param.destination_id,
    "q-check-in": param.check_in,
    "q-check-out": param.check_out,
    "q-rooms": 1,
    "f-star-rating": "5,4,3,2,1",
    "f-accid": 1,
    "start-index": 8,
    "resolved-location": "CITY:1063515:UNKNOWN:UNKNOWN",  # new
    "pn": 2
}

listings_headers = {
    "accept": "application/json, text/javascript, */*; q=0.01",
    "accept-encoding": "gzip, deflate, br",
    "accept-language": "en-US,en;q=0.9,pt;q=0.8",
    "cache-control": "no-cache",
    "content-type": "application/javascript",
    "cookie": "akacd_pr_20=1597178903~rv=40~id=32b7b6f7639eb6dcbd407b6ec499910c; bm_sz=9EDAC6D0123370579A928262C5185C8E~YAAQDZt6XHd4Y5lyAQAAeGpKqgjvuDnqC1Sz20quLEGgpIbiGSnXL+REk404Bk8zk/wN7PmaADXboreCOzkuSEIf1dxBjmfkuR3hKTAUrqQWVDm89S2JigeQSBbqSUD2tnQoIfwgt4SW+2NptiNa2B0f1HbWFJ3d/SRBpdeYB5GDkSotdDZu3W5GODKRyo24; asc=1; visitId=67d62b03-2f70-4c3b-9e70-a05eef86139c; SESSID=m2VGp6G3rTt6NJL6UHkw9tv5d9.hpa-74cd7c9dbb-mptg6; guid=6577d7d9-b497-44a2-90dd-c0cae3ecf474; user=QSplbl9HQnxIQ09NX1VL; dr=AAA~1591996398~AC256D453887E7598ECDB314AF5EB169C972C297A7EBF69D393777EEB4204837; _ga=GA1.2.1901412547.1591996401; _gid=GA1.2.1782156065.1591996401; AMCVS_C00802BE5330A8350A490D4C%40AdobeOrg=1; s_ecid=MCMID%7C03624445163088631420702441923045447796; AMCV_C00802BE5330A8350A490D4C%40AdobeOrg=-1330315163%7CMCIDTS%7C18426%7CMCMID%7C03624445163088631420702441923045447796%7CMCAAMLH-1592601200%7C6%7CMCAAMB-1592601200%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1592003600s%7CNONE%7CMCAID%7CNONE; s_cc=true; xdid=6b48c01c-8407-4636-ad84-2b58e861495b|1591996401|uk.hotels.com; mvthistory=eJxNjzkOAjAMBH8U%2BYyPlgYJISpqav7A40liI9FNJqu1HT54wHgTJbIP2oyWZDbssKeEtsdEQFkIG3TIseuBK3KsEI%2BIrSNRwcoqdDNvjpYIBWZe4NQtblh5SwyZRxJ4%2FEqInXulJCUaWGHSWeWkriVpcXTDZCm5ViYruxO8rz0fmoJYSwiq1AxZPLmlQSU5haTOEwasKkuRSSUVux832x97MW%2BODnPfsGaFn1mf6%2BVxfz1vX%2B8rV8U%3D; cPol=1; cbShown=1; _gcl_au=1.1.1274818481.1591996424; homepage_search_data=TGlzYm9uLCBQb3J0dWdhbA..%2F%2F14%2F06%2F2020%2F%2F15%2F06%2F2020%2F%2F2%2F%2Fdd%2FMM%2Fyyyy%2F%2F1063515%2F%2F; AFFLB=A; s_sq=%5B%5BB%5D%5D; aws=1; _gat=1; _abck=BAA6CDD4EFB38DACE8565EACB249D42A~0~YAAQDZt6XGGwY5lyAQAAxAN1qgQZXKVYTA8emOjrBJV5geuvADmqjDG6knXhjIsp66uXS/V8oZeJU+P9L4phx898cnb3zFDwPX15jWKfTaJisG8MX2dUNMPG3sKGCnc/3CXrwUuGja9As4tpql65jfXxib8jwR6XAFw6tRBHIszTEnkbxTjw5o2xhZluKK3JAlrAZSTwYhAcFZjU9lJ9LalnBWfgI04MyvN20ip76F6iQt+Dw6CfdV34WgKjmXSYgzsdAwbinalzzbRdnYjtro6O7yop/ou/PxZT1lZwrl6RqeGr/D0H2Kd2mwzqLxKdXwcQ72+hjQ==~-1~-1~-1; Session_Pageviews=6; _uetsid=857c30fb-2a78-7eaa-3bde-66e7ee799d8b; _uetvid=8d44dd77-a7f7-992c-84fa-b9f29df6e298",
    "pragma": "no-cache",
    "referer": "https://uk.hotels.com/search.do?resolved-location=CITY%3A1063515%3AUNKNOWN%3AUNKNOWN&destination-id=1063515&q-destination=Lisbon,%20Portugal&q-check-in=2020-06-14&q-check-out=2020-06-15&q-rooms=1&q-room-0-adults=2&q-room-0-children=0",
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-origin",
    "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.3",
    "x-requested-with": "XMLHttpRequest"
}

# listings_url = "https://uk.hotels.com/search/listings.json?destination-id=1063515&q-check-out=2020-06-15&q-destination=Lisbon,%20Portugal&q-room-0-adults=2&pg=1&q-rooms=1&start-index=8&q-check-in=2020-06-14&resolved-location=CITY:1063515:UNKNOWN:UNKNOWN&q-room-0-children=0&pn=2"


# client = httpx.AsyncClient(http2=True)
with httpx.Client(http2=True) as client:
    r = client.get(listings_url, params=listings_parameters,
                   headers=listings_headers)
    page_1 = json.loads(r.text)

    # r = client.get("https://uk.hotels.com/search/listings.json" +
    #                page_1['data']['body']['searchResults']['pagination']['nextPageUrl'], headers=listings_headers)
    # page_2 = json.loads(r.text)


results = page_1['data']['body']['searchResults']['results']

# results.extend(page_2['data']['body']['searchResults']['results'])


class Hotel:

    def function(self):
        pass


hotels = []
for i in range(0, len(results)):

    result = results[i]

    hotels.append(Hotel())

    # name
    hotels[i].name = results[i]['name']

    # cover photo
    hotels[i].search_cover_photo = 'https://exp.cdn-hotels.com' + \
        results[i]['optimizedThumbSourceUrl']

    # stars
    hotels[i].stars = results[i]['starRating']

    # score
    hotels[i].score = results[i]['guestReviews']['rating']

    # number of reviews
    hotels[i].nr_reviews = results[i]['guestReviews']['total']

    # city
    hotels[i].city = results[i]['address']['locality']

    # district
    hotels[i].district = results[i]['neighbourhood']

    # distance center
    hotels[i].distance_center = results[i]['geoBullets'][0][:3]

    # room name
    hotels[i].room_name = "Double Room"

    # bed type
    hotels[i].room_bed_type = "1 Double Bed"

    # cancellation policy
    hotels[i].room_cancellation_policy = ""
    if results[i]['ratePlan']['features']['freeCancellation'] == True:
        hotels[i].room_cancellation_policy = "Free cancellation"

    # payment policy
    hotels[i].room_payment_policy = ""

    # price
    hotels[i].price = results[i]['ratePlan']['price']['current']

    # coords
    hotels[i].coords = results[i]['coordinate']


# destination header
destination_header = page_1['data']['body']['header']
# search url for debug
url = page_1['data']['body']['searchResults']['pagination']['nextPageUrl']


class output:

    def function(self):
        pass


output.hotels = [ob.__dict__ for ob in hotels]


# print (pass to php)
print(json.dumps([output.hotels, destination_header, url]))
