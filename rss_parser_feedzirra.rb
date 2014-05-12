# encoding: utf-8

require 'feedzirra'

source_url = "http://www.google.com/alerts/feeds/05546308791182870999/12557010243017956011"

feed =  Feedzirra::Feed.fetch_and_parse(source_url)

puts feed.title
