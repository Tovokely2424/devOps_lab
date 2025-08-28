# 📞 Call Center Quality Management System – DevOps Practice Platform

This project is a full-stack application developed in Symfony and Twig, designed for quality monitoring in call centers. More importantly, it serves as a **DevOps lab environment**, allowing the implementation and testing of various DevOps practices from scratch to production.

---

## 🎯 Project Purpose

While the core functionality is focused on call center quality management, the main objective is to provide a **real-world application** on which to apply and practice all key stages of a **DevOps lifecycle**, including:

- Infrastructure as Code (IaC)
- Continuous Integration / Continuous Deployment (CI/CD)
- Configuration Management
- Containerization and Orchestration
- Monitoring and Logging
- Security and Compliance
- Automation and Testing

This project is used as a personal DevOps playground to experiment, learn, and demonstrate DevOps workflows and tools.

---

## 🧠 Functional Overview

A web application for managing and evaluating the quality of agent calls in a call center, with the following features:

### ✅ Key Features

- 📊 **Dynamic Scoring Grid**: Fully customizable by administrators or quality controllers.
- 🔐 **Role-Based Access Control**:
  - **Agent**: Can make calls and view quality evaluations.
  - **Controller**: Can evaluate calls, manage the evaluation grid.
  - **Administrator**: Manages users, access rights, evaluation parameters, and grid logic.
- 📝 **Detailed Feedback**: Each call evaluation includes criteria-based scoring and comments.
- 📈 **Performance History**: Agents and controllers can access historical data and trends.

---

## 🛠️ Tech Stack

### 🔧 Development

- **Backend**: PHP 8.x (Symfony Framework)
- **Frontend**: Twig templating, Vanilla JavaScript
- **Database**: MySQL / PostgreSQL
- **Authentication**: Symfony Security Component

### 🚀 DevOps Stack

> *(This is the real focus of the project)*

- **Version Control**: Git, GitHub
- **CI/CD**: GitHub Actions / GitLab CI / Jenkins (depending on experiment)
- **IaC**: Terraform / Ansible
- **Containers**: Docker, Docker Compose
- **Orchestration**: Kubernetes (via Minikube / k3s / GKE)
- **Monitoring**: Prometheus, Grafana
- **Logging**: ELK Stack (Elasticsearch, Logstash, Kibana)
- **Secrets Management**: HashiCorp Vault / Kubernetes Secrets
- **Hosting / Deployment**: Local (Dev), Cloud (Test/Prod) – AWS / GCP (as needed)

---

## 📦 Installation (Development Environment)

```bash
# Clone the repository
git clone git@github.com:Tovokely2424/callcenter-devops-lab.git

cd callcenter-devops-lab

# Start local development environment using Docker
docker-compose up --build

# Roadmap
The project will serve as the base for the following:
 Git & Branching Strategy (Git Flow)
 Basic CI with GitHub Actions
 Dockerization of Symfony App
 Kubernetes Deployment
 Helm Chart Packaging
 GitOps with ArgoCD or Flux
 Centralized Logging and Monitoring
 Infrastructure Provisioning with Terraform
 Secrets Management with Vault
(Roadmap will be updated as progress is made)

📄 License
MIT License – Free to use, modify and improve.

🙌 Contributions
This project is primarily for personal learning and experimentation, but contributions, feedback, or ideas are welcome!