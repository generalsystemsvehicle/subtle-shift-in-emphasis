#!/bin/bash

# We'll only runchecks on changes that are a part of this commit
# So let's stash others
git stash -q --keep-index

#
# Now we can do our test...
#
composer test
ERROR=$?

# We're done with checks, we can unstash changes
git stash pop -q

if [ "${ERROR}" -ne "0" ]
then
  echo "Commit aborted."
  exit ${ERROR}
fi

echo "All good, proceeding to push..."
