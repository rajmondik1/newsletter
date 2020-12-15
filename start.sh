#!/bin/bash
docker-compose up -d
cd client/
xdg-open http://localhost:8080/ 
npm run serve
