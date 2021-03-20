2.times do
    Task.create({
        last_date: Faker::Date.backward(days: 14),
        mytask: Faker::Lorem.word,
        priority: 1,
        is_done: 0,
        user_id: 3
    })
end