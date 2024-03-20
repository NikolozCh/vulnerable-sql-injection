pipeline {
    agent any
    environment {
        // PL/SQL
        ZIP_PLSQL_OUTFILE="${WORKSPACE}/vc-php.zip" 
        FILES_TO_ZIP_PLSQL="pl_sql/**.php"
    }

    stages {
        stage('Create zip file') {
            steps {
                script {
                    zip zipFile: env.ZIP_PLSQL_OUTFILE, overwrite: true, glob: env.FILES_TO_ZIP_PLSQL
                }
            }
        }
    }

    post {
        success {
            // PL/SQL
            veracode canFailJob: true, scanPollingInterval: 30, scanName: "Jenkins - ${env.BUILD_NUMBER}", applicationName: "PHP App", criticality: "Medium", sandboxName: "Login Data", waitForScan: true, timeout: 30, deleteIncompleteScan: false, uploadIncludesPattern: "vc-php.zip", scanIncludesPattern: "vc-php.zip"
        }
    }
}