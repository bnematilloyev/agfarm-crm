#!/bin/bash

php init --env=Production --overwrite=All && php yii serve --host=0.0.0.0 --port=8080
