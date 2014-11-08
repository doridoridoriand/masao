require 'pp'
require 'csv'

class CSVMerger

  def save_csv
    CSV.open('./merged.csv', 'wb') do |csv|
      merge_array_from_csv.each do |element|
        csv << element
      end
    end
  end

  def merge_array_from_csv
    parseList = load_csv('parseList.csv')
    accountList = load_csv('accountList.csv')

    generated_array = []
    generated_array_element = []

    for i in 0..(parseList.count.to_i - 1)
      for j in 0..(accountList.count.to_i - 1)
        if (parseList[i][1] == accountList[j][0])
          generated_array_element.concat(parseList[i]).concat(accountList[j])
          generated_array << generated_array_element.pop(8).uniq!
        end
      end
    end
    return generated_array
  end

  def load_csv(target_file_name)
    return CSV.parse(open('./' << target_file_name).read)
  end
end

csv_merger = CSVMerger.new()
csv_merger.save_csv
