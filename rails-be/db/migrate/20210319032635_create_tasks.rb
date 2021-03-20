class CreateTasks < ActiveRecord::Migration[6.1]
  def change
    create_table :tasks do |t|
      t.date :last_date
      t.string :mytask
      t.integer :priority
      t.integer :is_done
      add_column :user_id, :integer

      t.timestamps
    end
  end
end
