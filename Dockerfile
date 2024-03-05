FROM node:latest as node

WORKDIR /app

COPY . .

RUN npm ci
RUN npm run build

FROM golang:1.22-alpine as builder

WORKDIR /usr/src/app

COPY go.mod go.sum ./
RUN go mod download && go mod verify

COPY . .
RUN go build -v -o bin ./

FROM gcr.io/distroless/base-debian11
WORKDIR /

COPY --from=builder /usr/src/app/bin /bin
COPY --from=builder /usr/src/app/static /static
COPY --from=builder /usr/src/app/views /views
COPY --from=node /app/static/css /static/css

EXPOSE 3000

USER nonroot:nonroot

ENTRYPOINT ["bin"]
