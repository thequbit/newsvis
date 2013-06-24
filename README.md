newsvis
=======

Visualize statistics pulled from news sites.

#### What happens ####

The runall.sh script runs every hour.  The scripts pull the news articles from the various news websites that scripts have been written for.  Those articles are then parsed, and using nltk, a histogram of words is produced.  Those words then are saved to the database with their frequency.  An API is available for making 'word clouds' of the current data.
