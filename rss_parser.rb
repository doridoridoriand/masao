# encoding: utf-8

require 'rss'
require 'uri'

rss_source = "http://www.google.com/alerts/feeds/05546308791182870999/12557010243017956011"

rss = nil
begin
  rss = RSS::Parser.parse(rss_source, true)
rescue RSS::InvalidRSSError
  rss = RSS::Parser.parse(rss_source, false)
end


rss.items.each do |item|
  elements = Array.new

  content_title = item.title.to_s
  content_link = item.link.to_s
  content_description = item.content.to_s

  elements << content_title.scan(/<title type="html">([^"])</)
  elements << content_link.scan(/<link href=\"([^"])\">/)
  elements << content_description.scan(/<content type=\"html\">(^"*)</)

  p elements
end

