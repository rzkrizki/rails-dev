module Api
    class TasksController < ApplicationController
        def index
            tasks = Task.order('created_at DESC');
            render json: {status: 'success', message:'Loaded task data', data:tasks},status: :ok
        end

        def show
            if Task.exists?(id: params[:id])
                task = Task.find(params[:id]);
                render json: {status: 'success', message:'Loaded task id', data:task},
                status: :ok
            else
                render json: {status: 'failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end
        end

        def create
            task = Task.new(task_params)

            if task.save
                render json: {status: 'success', message:'Saved task', data:task},
                status: :ok
            else
                render json: {status: 'error', message:'Task not saved',
                data:task.errors},
                status: :unprocessable_entity
            end
        end

        def destroy
            if Task.exists?(id: params[:id])
                Task.destroy(params[:id])
                render json: {status: 'success', message:'Task Deleted'},
                status: :ok
            else
                render json: {status: 'failed', message:'User not Found',
                data:[]},
                status: :unprocessable_entity
            end

        end

        def update

            if Task.exists?(id: params[:id])
                task = Task.find(params[:id]);
                if task.update(task_params)
                    render json: {status: 'success', message:'Task updated', data:task},
                    status: :ok
                else
                    render json: {status: 'error', message:'Task not updated',
                    data:task.errors},
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

        def task_params
            params.permit(:last_date, :mytask, :priority, :is_done, :user_id)
        end

    end
end