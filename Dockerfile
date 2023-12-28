FROM node:latest as node

WORKDIR /app

COPY . .

RUN npm ci
RUN npm run build

FROM golang:1.21-alpine as builder

RUN go install github.com/a-h/templ/cmd/templ@latest

WORKDIR /usr/src/app

COPY go.mod go.sum ./
RUN templ generate
RUN go mod download && go mod verify

COPY . .
RUN go build -v -o bin ./

FROM gcr.io/distroless/base-debian11
WORKDIR /

COPY --from=builder /usr/src/app/bin /bin
COPY --from=builder /usr/src/app/templates /templates
COPY --from=node /app/static/css /static/css

EXPOSE 3000

USER nonroot:nonroot

ENTRYPOINT ["bin"]
