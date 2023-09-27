FROM node:18

WORKDIR /app

COPY package*.json ./

RUN yarn install

COPY ./ .

EXPOSE 8080

CMD [ "yarn", "run", "dev"]

# FROM node:16 as build-stage
# WORKDIR /app
# COPY package*.json ./
# RUN npm install
# COPY ./ .
# RUN npm run build

# FROM nginx as production-stage
# EXPOSE 3000
# RUN mkdir /app
# COPY nginx.conf /etc/nginx/conf.d/default.conf
# COPY --from=build-stage /app/dist /app
