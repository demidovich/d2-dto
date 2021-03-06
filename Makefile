.DEFAULT_GOAL := help

UID := $(shell id -u)
GID := $(shell id -g)

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build docker image
	@docker build --build-arg UID=${UID} --build-arg GID=${GID} --tag d2-dto .

up: build ## Start container
	@docker run --rm -d --name d2-dto -v $(PWD):/app --user ${UID}:${GID} d2-dto

down: ## Start container
	@docker stop d2-dto

rmi: down ## Remove docker image
	@docker rmi -f d2-dto

shell: ## Shell of php container
	@docker exec -ti --user ${UID}:${GID} d2-dto /bin/bash
