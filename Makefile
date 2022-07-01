# apt install make imagemagick librsvg2-bin optipng advancecomp

ASSETS := public/favicon.ico \
	public/apple-touch-icon.png

build: $(ASSETS)

package: build post.test.de.co.ua.tar.gz

post.test.de.co.ua.tar.gz:
	tar zcf $@ src/ public/ bootstrap.php

public/favicon.ico: public/favicon.svg
	rsvg-convert $< -w 32 -h 32 | convert - $@

public/apple-touch-icon.png: public/favicon.svg
	rsvg-convert $< -w 180 -h 180 > $@
	optipng $@
	advpng -z4 $@

clean:
	rm -fv $(ASSETS)

.PHONY: build package clean
