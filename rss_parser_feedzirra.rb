# encoding: utf-8

require 'feedjira'

source_url = "http://www.google.com/alerts/feeds/05546308791182870999/12557010243017956011"

feed =  Feedjira::Feed.fetch_and_parse source_url

p feed.title.force_encoding("UTF-8")
puts feed.url
puts feed.entries

entry = feed.entries.first
puts entry.title
puts entry.url
