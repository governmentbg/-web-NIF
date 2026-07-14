# Docker compose orchestration

The public orchestration should be appended to a webadmin one, by appending the corresponding containers to the admin up command.

For example: ```docker compose -f ./../../webadmin/docker/compose.yml -f ./compose.yml```

Make sure the admin's docker/.env file contains the location of the public's docker folder. This is required for docker to properly resolve relative paths (as paths are resolved relative to the first compose file).
