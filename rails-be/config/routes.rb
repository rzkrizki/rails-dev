Rails.application.routes.draw do
  namespace 'api' do
    resources :users, :tasks, :login
  end
end
