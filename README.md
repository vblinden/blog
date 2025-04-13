## Blog

This is the repository of my personal blog.

docker buildx build --platform linux/amd64 -t blog:latest .
docker tag blog:latest registry.vblinden.dev/personal/blog:latest
docker push registry.vblinden.dev/personal/blog:latest
