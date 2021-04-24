git:
		git add .
		git commit -m "$m"
		git push origin master

heorku:
		git push heroku master
		heroku open

both: git && heroku