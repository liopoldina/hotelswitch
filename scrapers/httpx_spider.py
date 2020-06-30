#!C:/Users/Pedro/AppData/Local/Programs/Python/Python38/python.exe
import json
import sys
import httpx
import time
from datetime import datetime
from datetime import timedelta

if sys.argv[1] == "initial":
    mode = sys.argv[1]
    check_in = sys.argv[2]
    check_out = sys.argv[3]
    destination_name = sys.argv[4]
    if len(sys.argv) == 6:
        destination_id = sys.argv[5]
    else:
        destination_id = ""

if sys.argv[1] == "xhr":
    mode = sys.argv[1]
    check_in = sys.argv[2]
    check_out = sys.argv[3]
    destination_name = sys.argv[4]
    destination_id = sys.argv[5]
    xhr_url = sys.argv[6]

# mode = "xhr"
# check_in = "2020-06-21"
# check_out = "2020-06-22"
# destination_name = "Lisbon, Portugal"
# destination_id = "1063515"
# xhr_url = "https://uk.hotels.com/search/listings.json?q-check-out=2020-07-02&f-price-currency-code=EUR&q-destination=Lisbon,%20Portugal&f-star-rating=5,4,3&start-index=4&q-check-in=2020-07-01&q-room-0-children=0&points=false&destination-id=1063515&q-room-0-adults=2&pg=2&q-rooms=1&f-price-multiplier=1&f-price-max=45&resolved-location=CITY:1063515:UNKNOWN:UNKNOWN&f-accid=1&pn=1"


user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36"

with open('scrapers/cookies.json') as file:
    cookie_settings = json.load(file)

cookie_date = datetime.strptime(cookie_settings[-1]['date'], '%d/%m/%y')
today = datetime.now()

# set user agent and cookie
if today > cookie_date + timedelta(days=1):

    search_headers = {
        "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding": "gzip, deflate, br",
        "accept-language": "en-US,en;q=0.5",
        "cache-control": "no-cache",
        "pragma": "no-cache",
        "referer": "https://www.google.com/",
        "sec-fetch-dest": "document",
        "sec-fetch-mode": "navigate",
        "sec-fetch-site": "same-origin",
        "sec-fetch-user": "?1",
        "upgrade-insecure-requests": "1",
        "user-agent": "" + user_agent + ""
    }
    with httpx.Client(http2=True, headers=search_headers, timeout=15.0) as client:
        r_home = client.get("https://uk.hotels.com")
        time.sleep(3)
        r_search = client.get(
            "https://uk.hotels.com/search.do?resolved-location=CITY%3A549499%3AUNKNOWN%3AUNKNOWN&destination-id=549499&q-destination=London,%20England,%20United%20Kingdom&q-check-in=2020-12-31&q-check-out=2021-01-01&q-rooms=1&q-room-0-adults=2&q-room-0-children=0")
        time.sleep(3)
        r_listings = client.get(
            "https://uk.hotels.com/search/listings.json?destination-id=549499&q-check-out=2021-01-01&q-destination=London,%20England,%20United%20Kingdom&q-room-0-adults=2&pg=1&q-rooms=1&start-index=12&q-check-in=2020-12-31&resolved-location=CITY:549499:UNKNOWN:UNKNOWN&q-room-0-children=0&pn=2")

        cookie_settings.append({
            "date": today.strftime('%d/%m/%y'),
            "user_agent": user_agent,
            "cookie": r_listings.request.headers._list[14][1].decode("utf-8")
        })

        del cookie_settings[0]
        with open('scrapers/cookies.json', 'w') as outfile:
            json.dump(cookie_settings, outfile)

# Listings
listings_url = "https://uk.hotels.com/search/listings.json"

listings_parameters = {
    "cur": "EUR",
    "q-destination": destination_name,
    "destination-id": destination_id,
    "q-check-in": check_in,
    "q-check-out": check_out,
    "q-rooms": 1,
    "f-star-rating": "5,4,3,2,1",
    "f-accid": 1,
    "start-index": 0,
    # "resolved-location": "CITY:" + destination_id + ":UNKNOWN:UNKNOWN",  # dá erro quando não existe destination e de qualquer forma temos que arranjar o "city"
    "pn": 1
}

listings_headers = {
    "accept": "application/json, text/javascript, */*; q=0.01",
    "accept-encoding": "gzip, deflate, br",
    "accept-language": "en-US,en;q=0.5",
    "cache-control": "no-cache",
    "content-type": "application/javascript",
    "cookie": "" + cookie_settings[-1]['cookie'] + "",
    "pragma": "no-cache",
    "referer": "https://uk.hotels.com/search.do?resolved-location=CITY%3A" + destination_id + "%3AUNKNOWN%3AUNKNOWN&destination-id=" + destination_id + "&q-destination="+destination_name+"&q-check-in=" + check_in + "&q-check-out=" + check_out + "&q-rooms=1&q-room-0-adults=2&q-room-0-children=0",
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-origin",
    "user-agent": "" + user_agent + "",
    "x-requested-with": "XMLHttpRequest"
}


if mode == "initial":
    with httpx.Client(http2=True, timeout=10.0) as client:
        r = client.get(listings_url, params=listings_parameters,
                       headers=listings_headers)
        page_1 = json.loads(r.text)
    # r = client.get("https://uk.hotels.com/search/listings.json" +
    #                page_1['data']['body']['searchResults']['pagination']['nextPageUrl'], headers=listings_headers)
    # page_2 = json.loads(r.text)
    # results.extend(page_2['data']['body']['searchResults']['results'])
        results = page_1['data']['body']['searchResults']['results']

if mode == "xhr":
    with httpx.Client(http2=True, timeout=10.0) as client:
        r = client.get(xhr_url, headers=listings_headers)
        page_1 = json.loads(r.text)
        results = page_1['data']['body']['searchResults']['results']


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
    if 'guestReviews' in results[i]:
        hotels[i].score = results[i]['guestReviews']['rating']

    # number of reviews
    if 'guestReviews' in results[i]:
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


# destination name
destination_name = page_1['data']['body']['query']['destination']['value']

# destination id
destination_id = page_1['data']['body']['query']['destination']['id']

# destination header
destination_header = page_1['data']['body']['header']

# next_url
if 'pagination' in page_1['data']['body']['searchResults']:
    next_url = page_1['data']['body']['searchResults']['pagination']['nextPageUrl']
else:
    next_url = "no results"


class output:

    def function(self):
        pass


output.hotels = [ob.__dict__ for ob in hotels]


# print (pass to php)
print(json.dumps([output.hotels, destination_name,
                  destination_id, destination_header, next_url]))
