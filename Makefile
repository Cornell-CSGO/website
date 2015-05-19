ifeq (sync, $(firstword $(MAKECMDGOALS)))
        SYNC_NAME := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
        $(eval $(SYNC_NAME):;@:)
endif

sync:
	rsync -rvuz . $(SYNC_NAME)@lion.cs.cornell.edu:/cucs/web/cs/csgo/ \
        --exclude '.svn' --exclude '.git' --exclude "*~" --exclude '*.*~' --exclude 'debug*' \
	--exclude '.hs' --exclude '.py'

install:
	sudo mount /cs/remote && rsync -rvuz . /cs/remote/csgo/ \
        --exclude '.svn' --exclude '.git' --exclude "*~" --exclude '*.*~' --exclude 'debug*' \
	--exclude '.hs' --exclude '.py' && sudo umount /cs/remote/

