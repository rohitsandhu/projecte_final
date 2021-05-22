FROM node:14

WORKDIR /app

COPY socket_app/ ./

RUN npm install -g nodemon
RUN npm install

EXPOSE 3000

CMD [ "npm", "run" , "start"]
