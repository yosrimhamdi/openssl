git:
		git add .
		git commit -m "$m"
		git push origin master

heroku:
		git push heroku master
		heroku open

logs:
		heroku logs --tail

both:
	$(MAKE) git
	$(MAKE) heroku