module Api
    class LoginController < ApplicationController
        def index
            if User.exists?(username: params[:username])
                user = User.where(username: params[:username]).first
                if user && user.authenticate(params[:password])
                    render json: {status: 'success', message:'Login Success', data:user},
                    status: :ok
                else
                    render json: {status: 'failed', message:'Password Wrong', data:user},
                    status: :ok
                end
            else
                render json: {status: 'failed', message:'Username Wrong',
                data:[]},
                status: :unprocessable_entity
            end
        end
    end
end