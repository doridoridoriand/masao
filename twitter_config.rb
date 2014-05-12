# encoding: utf-8

require 'twitter'
require 'faraday'
require 'simple_oauth'

class Configure
  def account_config
    Twitter.configuredo |config|
    config.consumer_key = ""
    config.consumer_secret = ""
    config.access_token = ""
    config.access_token_secret = ""
  end
end
