# -*- encoding: utf-8 -*-

require 'nokogiri'
require 'open-uri'

source_url = 'http://www.google.com/alerts/feeds/05546308791182870999/12557010243017956011'

xml = Nokogiri::XML(open(source_url).read)
p xml

item_nodes = xml.xpath('//entry')
p item_nodes

item_nodes.each do |entry|
  p entry
  puts entry.xpath('title').text
  puts entry.xpath('link').text
  puts entry.xpath('content').text
end
