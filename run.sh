#!/bin/bash

php init --env=Production --overwrite=All && php yii serve 127.0.0.1:8080
