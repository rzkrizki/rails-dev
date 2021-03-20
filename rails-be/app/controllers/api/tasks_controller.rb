module Api
    class TasksController < ApplicationController
        def index
            tasks = Task.where(user_id: params[:user_id]).order('created_at DESC');
            render json: {status: 'SUCCESS', message:'Loaded task data', data:tasks},status: :ok
        end

        def show
            if Task.exists?(id: params[:id])
                task = Task.find(params[:id]);
                render json: {status: 'SUCCESS', message:'Loaded task id', data:task},
                status: :ok
            else
                render json: {status: 'Failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end

        def create
            task = Task.new(task_params)

            if task.save
                render json: {status: 'SUCCESS', message:'Saved task', data:task},
                status: :ok
            else
                render json: {status: 'ERROR', message:'Task not saved',
                data:task.errors},
                status: :unprocessable_entity
            end
        end

        def destroy
            if Task.exists?(id: params[:id])
                Task.destroy(params[:id])
                render json: {status: 'SUCCESS', message:'Deleted task'},
                status: :ok
            else
                render json: {status: 'Failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end

        end

        def update

            if Task.exists?(id: params[:id])
                task = Task.find(params[:id]);
                if task.update(task_params)
                    render json: {status: 'SUCCESS', message:'Update task', data:task},
                    status: :ok
                else
                    render json: {status: 'ERROR', message:'Task not update',
                    data:task.errors},
                    status: :unprocessable_entity
                end
            else
                render json: {status: 'Failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end


        private

        skip_before_action :verify_authenticity_token

        def task_params
            params.permit(:last_date, :mytask, :priority, :is_done, :user_id)
        end

    end
end