```
# ALPR in ongeremde scenario's

## Inleiding

Dit archief bevat de implementatie van de auteur van de ECCV 2018 paper "License Plate Detection and Recognition in Unscontrained Scenarios".

* Document webpagina: http://sergiomsilva.com/pubs/alpr-unconstrained/

Als u resultaten geproduceerd door onze code gebruikt in een publicatie, citeer dan onze paper:

```
@INPROCEEDINGS{silva2018a,
  author={S. M. Silva en C. R. Jung}, 
  booktitle={2018 European Conference on Computer Vision (ECCV)}, 
  title={License Plate Detection and Recognition in Unconstrained Scenarios}, 
  year={2018}, 
  pages={580-596}, 
  doi={10.1007/978-3-030-01258-8_36}, 
  month={Sep},}
```

## Vereisten

Om de code gemakkelijk te kunnen uitvoeren, moet je het Keras framework met TensorFlow backend geïnstalleerd hebben. Het Darknet framework staat in de map "darknet" en moet worden gecompileerd voordat de tests worden uitgevoerd. Om Darknet te bouwen typt u gewoon "make" in de map "darknet":

``hellscript
$ cd darknet && make
```

**De huidige versie is getest op een Ubuntu 16.04 machine, met Keras 2.2.4, TensorFlow 1.5.0, OpenCV 2.4.9, NumPy 1.14 en Python 2.7.**.

## Modellen downloaden

Na het bouwen van het Darknet framework moet u het "get-networks.sh" script uitvoeren. Dit zal alle getrainde modellen downloaden:

``hellscript
$ bash get-networks.sh
```

## Een eenvoudige test uitvoeren

Gebruik het script "run.sh" om onze ALPR aanpak uit te voeren. Het vereist 3 argumenten:
* __Input directory (-i):__ moet minstens 1 afbeelding in JPG of PNG formaat bevatten;
* __Output directory (-o):__ tijdens het herkenningsproces worden in deze directory veel tijdelijke bestanden gegenereerd die aan het eind worden gewist. De resterende bestanden zijn gerelateerd aan de automatisch geannoteerde afbeelding;
* __CSV-bestand (-c):__ geef een uitvoer-CSV-bestand op.

``hellscript
$ bash get-networks.sh && bash run.sh -i samples/test -o /tmp/output -c /tmp/output/results.csv
```

## De LP-detector trainen

Om het LP-detectornetwerk vanaf nul te trainen, of fijn af te stellen voor nieuwe monsters, kunt u het train-detector.py script gebruiken. In de map samples/train-detector staan 3 geannoteerde samples die alleen voor demonstratiedoeleinden worden gebruikt. Om onze experimenten correct te reproduceren, moet deze map worden gevuld met alle annotaties uit de trainingsset, en de bijbehorende afbeeldingen uit de oorspronkelijke datasets.

Het volgende commando kan worden gebruikt om het netwerk vanaf nul te trainen, rekening houdend met de gegevens in de map train-detector:

``shellscript
$ mkdir models
$ python create-model.py eccv models/eccv-model-scracth
$ python train-detector.py --model models/eccv-model-scracth --name my-trained-model --train-dir samples/train-detector --output-dir models/my-trained-model/ -op Adam -lr .001 -its 300000 -bs 64
```

Gebruik voor fijnafstelling uw model met de optie --model.

## Een woord over GPU en CPU

We weten dat niet iedereen over een NVIDIA kaart beschikt, en dat het soms lastig is om CUDA goed te configureren. Daarom hebben we ervoor gekozen om in de Darknet makefile standaard CPU te gebruiken in plaats van GPU, om de meeste mensen een gemakkelijke uitvoering te bieden in plaats van snelle prestaties. Daarom zullen de voertuigdetectie en OCR vrij traag zijn. Als je ze wilt versnellen, pas dan de Darknet makefile variabelen aan om GPU te gebruiken.

Vertaald met www.DeepL.com/Translator (gratis versie)
```