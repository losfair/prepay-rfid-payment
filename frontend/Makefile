RFID-Payment-Frontend:
	make -C ./src
	browserify -o build/bundle.js ts_compiled/*.js
	uglifyjs -o build/bundle.min.js build/bundle.js
	cp -r html/* build/
	cp -r prebuilt/* build/
