git:
		git add .
		git commit -m "$m"
		git push origin master

heroku:
		$(MAKE) m='publising' git
		git push heroku master
		heroku open