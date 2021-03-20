class Task < ApplicationRecord
    validates :last_date, presence: true
    validates :mytask, presence: true
    validates :priority, presence: true
    validates :is_done, presence: true
    validates :user_id, presence: true
end
