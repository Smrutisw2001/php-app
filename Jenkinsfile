pipeline {
    agent any

    environment {
        ECR_REPOSITORY = '026090533449.dkr.ecr.ap-south-1.amazonaws.com/php-app'
        IMAGE_TAG = "${env.BUILD_ID}"  // Jenkins build ID as image tag
        AWS_DEFAULT_REGION = 'ap-south-1'
        EC2_HOST = '13.233.207.245'
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Checkout code from the GitHub repository
                git 'https://github.com/Smrutisw2001/php-app.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Build Docker image from the source code
                    sh 'docker build -t php-app:${IMAGE_TAG} .'
                }
            }
        }

        stage('Login to AWS ECR') {
            steps {
                script {
                    // Use Jenkins credentials for AWS ECR login
                    withCredentials([aws(credentialsId: 'aws-credentials', region: AWS_DEFAULT_REGION)]) {
                        sh 'aws ecr get-login-password --region ${AWS_DEFAULT_REGION} | docker login --username AWS --password-stdin ${ECR_REPOSITORY}'
                    }
                }
            }
        }

        stage('Push Docker Image to ECR') {
            steps {
                script {
                    // Tag and push Docker image to ECR
                    sh 'docker tag php-app:${IMAGE_TAG} ${ECR_REPOSITORY}:latest'
                    sh 'docker push ${ECR_REPOSITORY}:latest'
                }
            }
        }

        stage('Deploy to EC2') {
            steps {
                script {
                    // Use Jenkins credentials for AWS and SSH
                    withCredentials([aws(credentialsId: 'aws-credentials', region: AWS_DEFAULT_REGION), 
                                      sshUserPrivateKey(credentialsId: 'ssh-private-key', keyFileVariable: 'SSH_KEY')]) {
                        sh """
                        ssh-keyscan -H 13.233.81.235 >> ~/.ssh/known_hosts
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "aws configure set aws_access_key_id ${AWS_ACCESS_KEY_ID}"
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "aws configure set aws_secret_access_key ${AWS_SECRET_ACCESS_KEY}"
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "aws configure set region ${AWS_DEFAULT_REGION}"
                        
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "aws ecr get-login-password --region ${AWS_DEFAULT_REGION} | docker login --username AWS --password-stdin ${ECR_REPOSITORY}"
                        
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "docker pull ${ECR_REPOSITORY}:latest"
                        
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "docker rm -f php-app || true"
                        
                        ssh -i \$SSH_KEY ubuntu@${EC2_HOST} "docker run -d -p 80:80 --name php-app ${ECR_REPOSITORY}:latest"
                        """
                    }
                }
            }
        }
    }
}
