module Api
    class LoginController < ApplicationController
        def index
            if User.exists?(username: params[:username])
                user = User.where(username: params[:username]).first
                if user && user.authenticate(params[:password])
                    render json: {status: 'SUCCESS', message:'Loaded user', data:user},
                    status: :ok
                else
                    render json: {status: 'Failed', message:'Password Wrong', data:user},
                    status: :ok
                end
            else
                render json: {status: 'Failed', message:'Password Wrong',
                data:[]},
                status: :unprocessable_entity
            end
        end
    end
end