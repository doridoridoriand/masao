buf = Array.new

File.open("data.txt") do |f|
  f.each_line do |line|
    buf << line.chomp
  end
end
