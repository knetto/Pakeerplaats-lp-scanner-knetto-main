IMG_FOLDER=/mnt/c/Users/corne/OneDrive/Documenten/school/klas3/parkeerplaats/fotos/

rm -rf /tmp/images
mkdir /tmp/images

while true
do
  watch -n 0.5 -g ls $IMG_FOLDER > /dev/null
  echo slurping
  mv $IMG_FOLDER/* /tmp/images
  echo geslurpt
  echo yeeting
  ./run.sh -i /tmp/images -o /tmp/output/
  echo geyeet
  rm /tmp/images/*
  rm /tmp/output/*
done