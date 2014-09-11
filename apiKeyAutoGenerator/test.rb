require 'open-uri'
require 'mechanize'

class Api_key_generator
  def auto_application_generator
    agent = Mechanize.new
    agent.user_agent_alias = 'Mac Mozilla'
    source = agent.get('https://twitter.com/login?redirect_after_login=https%3A//apps.twitter.com/')
    form_element = agent.page.form(:action => 'https://twitter.com/sessions')

    form_element.field_with(:name => 'session[username_or_email]').value = 'doridoridoriand'
    form_element.field_with(:name => 'session[password]').value = '19924128takahiro'

    main_page_after_login = agent.submit(form_element)
    create_application_page = main_page_after_login.links[6].click

    #create_application_form_element = create_application_page.form(:action => '/app/new')

    #create_application_form_element.field_with(:name => 'name').value = 'ooooooooooooooooooooooooooooooooouooooooo'
    #create_application_form_element.field_with(:name => 'description').value = 'unkounkooooooooooooooooooooo'
    #create_application_form_element.field_with(:name => 'url').value = 'http://google.com'
    #create_application_form_element.checkbox_with(:type => 'checkbox').check
    #create_application_form_element.click_button(create_application_form_element.button_with(:value => 'Create your Twitter application'))

    create_application_page.form(:action => '/app/new') do |form_elephant|
      form_elephant.field_with(:name => 'name').value = 'ooooooooooooooooooooooooooooooooouooooooo'
      form_elephant.field_with(:name => 'description').value = 'unkounkooooooooooooooooooooo'
      form_elephant.field_with(:name => 'url').value = 'http://google.com'
      form_elephant.checkbox_with(:type => 'checkbox').check
      #agent.submit(form_elephant)
      #p form_element.click_button(form_element.button_with(:value => 'Create your Twitter application'))
    end
    p create_application_page.form(:action => '/app/new').click_button
  end
end

api_key_generator = Api_key_generator.new
api_key_generator.auto_application_generator()

