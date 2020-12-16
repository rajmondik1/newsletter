#!/bin/bash
docker-compose up -d
(cd client/; npm run serve & xdg-open http://localhost:8080/) & (cd admin/; npm run dev)