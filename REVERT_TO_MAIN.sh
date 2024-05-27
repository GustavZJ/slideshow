#!/bin/bash
git rebase --quit
git reset --hard
git switch main
git pull origin main
