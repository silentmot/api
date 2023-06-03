pipeline {
agent any
 options {
    buildDiscarder logRotator(daysToKeepStr: '5', numToKeepStr: '6')
    }

  stages {
stage("Deploy to Devlopment"){
when {
    branch 'develop'
}
 steps {
    sh  'echo "Deployint to Devolpment ......"'
     sh 'cp ../SCRIPTS/mardam/bk/develop.sh .'
	 sh './develop.sh'

         }
            }
stage("Deploy to UAT"){
when {
    branch 'uat'
}
 steps {
    sh  'echo "Deployint to UAT ..... "'
	sh 'cp ../SCRIPTS/mardam/bk/uat.sh .'
	sh './uat.sh'
    
        }
            }
stage("Deploy to Testing"){
when {
    branch 'test'
}
 steps {
    sh  'echo "Deployint to Testing ......."'
	sh 'cp ../SCRIPTS/mardam/bk/test.sh .' 
    sh './test.sh'
       }
            }
  stage("Deploy to Stage"){
when {
    branch 'stage'
}
 steps {
     sh  'echo "Deployint to Stage ....."'
     sh 'cp ../SCRIPTS/mardam/bk/stage.sh .'
	 sh './stage.sh'       
       }
  }
   stage("Deploy to Produaction"){
when {
    branch 'master'
}
 steps {
     sh 'echo "Deploying to produaction"'
     sh 'cp ../SCRIPTS/mardam/bk/prod.sh . '
	 sh './prod.sh'

       }
  }
  }
post{
              always{

           googlechatnotification(
             url: 'id:BK-BUILDS',
             message: "#################${env.JOB_NAME} on branch ${env.BRANCH_NAME} is ##################### \
                 *******************${currentBuild.currentResult} *******************  \
               ** to view all details use below link **   ${env.BUILD_URL} " ,
             sameThreadNotification: 'true',
             suppressInfoLoggers: 'true'
           )
  }

  }

}
