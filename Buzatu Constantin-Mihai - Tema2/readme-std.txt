Am instalat Kubernetes
Am instalat Docker
Am instalat minikube
Am urmat tutorialul pentru a crea un deployment de Wordpress: https://kubernetes.io/docs/tutorials/stateful-application/mysql-wordpress-persistent-volume/
Am creat index.php
Am creat dockerfile, dupa care am dat comenzile
	docker build -t tema .
	docker tag tema localhost:32000/tema
	docker push localhost:32000/tema
Am urmat tutorialul pentru a crea un deployment pentru Apache cu Php: https://medium.com/akeo-tech/deploy-php-applications-using-kubernetes-870c87c0acf0
Am urmat tutorialul pentru a crea un deployment pentru CouchDB: https://faun.pub/deploying-a-couchdb-cluster-on-kubernetes-d4eb50a08b34
Din Azure, am adaugat la Inbound port rule porturile pentru a rula serviciile de Wordpress(80), MySql(3306), Apache(88), CouchDB(30984).
Din interfata de pe site-ul CouchDB, am creat o baza de date 'chat':
Din interfata de pe site-ul Wordpress, am introdus iframe-ul: <iframe src="http://localhost:88" style="width: 100%; height: 500px;"></iframe>
