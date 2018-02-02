.PHONY: test doc

test:
	./vendor/bin/phpcs src

doc:
	./vendor/bin/phpdoc
