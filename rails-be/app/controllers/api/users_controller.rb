module Api
    class UsersController < ApplicationController
        def index
            users = User.order('created_at DESC');
            render json: {status: 'success', message:'Loaded users data', data:users},status: :ok
        end

        def show
            if User.exists?(id: params[:id])
                user = User.find(params[:id]);
                render json: {status: 'success', message:'Loaded user id', data:user},
                status: :ok
            else
                render json: {status: 'failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end

        def create
            user = User.new(user_params)

            if(User.exists?(username: params[:username]))
                render json: {status: 'failed', message:'Username has been registered', data:user},
                status: :ok
            else
                if user.save
                    render json: {status: 'success', message:'Saved user', data:user},
                    status: :ok
                else
                    render json: {status: 'error', message:'User not saved',
                    data:user.errors},
                    status: :unprocessable_entity
                end
            end
        end

        def destroy
            if User.exists?(id: params[:id])
                user = User.find(params[:id]);
                user.destroy
                render json: {status: 'success', message:'User Deleted', data:user},
                status: :ok
            else
                render json: {status: 'failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end

        def update
            if User.exists?(id: params[:id])
                user = User.find(params[:id]);
                if user.update(user_params)
                    render json: {status: 'success', message:'Success Updated', data:user},
                    status: :ok
                else
                    render json: {status: 'error', message:'Failed Updated',
                    data:user.errors},
                    status: :unprocessable_entity
                end
            else
                render json: {status: 'failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end

        private

        skip_before_action :verify_authenticity_token

        def user_params
            params.permit(:name, :username, :password)
        end
    end
end