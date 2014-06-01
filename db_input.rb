# encoding: utf-8

require 'rubygems'
require 'active_record'

# DB ACCESS CONFIG
config = YAML.load_file('./database.yml')
ActiveRecord::Base.establish_connection(config["db"]["development"])

class User < ActiveRecord::Base
  self.table_name = 'test'
end

p User.all
