<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $hygiene = new Product();
    $hygiene->setName("Kit d'hygiène recyclable");
    $hygiene->setPrice(24.99);
    $hygiene->setShortDescription('Pour une salle de bain éco-friendly');
    $hygiene->setLongDescription(
      "Ce kit d'hygiène recyclable rassemble l’essentiel pour une salle de bain plus responsable : accessoires durables, matériaux réutilisables et packaging minimaliste. Pensé pour réduire au maximum les déchets, il remplace facilement les produits jetables du quotidien sans compromettre le confort. Idéal pour entamer une transition vers une routine plus écologique, à la maison comme en voyage."
    );
    $hygiene->setImagePath('images/products/kit recyclable.png');
    $manager->persist($hygiene);

    $shot = new Product();
    $shot->setName('Shot Tropical');
    $shot->setPrice(4.50);
    $shot->setShortDescription('Fruits frais, pressés à froid');
    $shot->setLongDescription(
      "Le Shot Tropical est un concentré de vitamines issu de fruits frais, pressés à froid pour conserver tous leurs nutriments. Ananas, mangue et passion s’allient pour offrir un goût intense et naturellement sucré, sans arômes artificiels ni conservateurs. À déguster le matin pour un boost d’énergie ou en milieu de journée pour une pause saine et rafraîchissante."
    );
    $shot->setImagePath('images/products/shot.png');
    $manager->persist($shot);

    $gourde = new Product();
    $gourde->setName('Gourde en bois');
    $gourde->setPrice(16.90);
    $gourde->setShortDescription('50cl, bois d’olivier');
    $gourde->setLongDescription(
      "Cette gourde en bois de 50cl, conçue en bois d’olivier, allie élégance naturelle et praticité au quotidien. Solide et durable, elle est une alternative idéale aux bouteilles en plastique, que ce soit au bureau, en cours ou en randonnée. Sa finition soignée et son toucher chaleureux en font un objet que l’on prend plaisir à emporter partout, tout en réduisant ses déchets."
    );
    $gourde->setImagePath('images/products/gourde.png');
    $manager->persist($gourde);

    $disque = new Product();
    $disque->setName('Disques Démaquillants x3');
    $disque->setPrice(19.90);
    $disque->setShortDescription('Solution efficace pour vous démaquiller en douceur ');
    $disque->setLongDescription(
      "Ces trois disques démaquillants réutilisables ont été pensés pour nettoyer votre peau en douceur tout en limitant votre impact environnemental. Utilisables avec votre démaquillant habituel ou simplement avec de l’eau, ils remplacent des dizaines de cotons jetables chaque mois. Faciles à laver et à réutiliser, ils s’intègrent parfaitement dans une routine beauté plus responsable."
    );
    $disque->setImagePath('images/products/disque.png');
    $manager->persist($disque);

    $bougie = new Product();
    $bougie->setName('Bougie Lavande & Patchouli');
    $bougie->setPrice(32);
    $bougie->setShortDescription('Cire naturelle');
    $bougie->setLongDescription(
      "Cette bougie Lavande & Patchouli, composée de cire naturelle, diffuse un parfum apaisant qui invite à la détente. La lavande apporte une note florale relaxante, tandis que le patchouli offre une touche plus chaleureuse et enveloppante. Parfaite pour créer une ambiance cocooning chez soi, elle brûle proprement et longtemps, sans dégager de fumées toxiques."
    );
    $bougie->setImagePath('images/products/bougie.png');
    $manager->persist($bougie);

    $brosse = new Product();
    $brosse->setName('Brosse à dent');
    $brosse->setPrice(5.40);
    $brosse->setShortDescription('Bois de hêtre rouge issu de forêts gérées durablement');
    $brosse->setLongDescription(
      "Cette brosse à dent en bois de hêtre rouge, issu de forêts gérées durablement, est une alternative écologique aux brosses en plastique. Son manche ergonomique assure une bonne prise en main, tandis que ses poils nettoient efficacement tout en restant doux pour les gencives. Idéale pour ceux qui souhaitent adopter une routine d’hygiène bucco-dentaire plus respectueuse de l’environnement."
    );
    $brosse->setImagePath('images/products/brosse.png');
    $manager->persist($brosse);

    $couvert = new Product();
    $couvert->setName('Kit couvert en bois');
    $couvert->setPrice(12.30);
    $couvert->setShortDescription('Revêtement Bio en olivier & sac de transport');
    $couvert->setLongDescription(
      "Ce kit de couverts en bois, avec revêtement bio en olivier et sac de transport, vous accompagne dans tous vos repas nomades : au bureau, en pique-nique ou en voyage. Réutilisables, légers et résistants, ils permettent d’éviter l’usage de couverts jetables en plastique. Le petit étui de transport facilite leur rangement dans un sac ou un tote bag, pour avoir toujours une solution durable à portée de main."
    );
    $couvert->setImagePath('images/products/couvert.png');
    $manager->persist($couvert);

    $deodorant = new Product();
    $deodorant->setName('Nécessaire, déodorant Bio');
    $deodorant->setPrice(8.50);
    $deodorant->setShortDescription('50ml déodorant à l’eucalyptus');
    $deodorant->setLongDescription(
      "Ce déodorant bio à l’eucalyptus, au format 50ml, offre une sensation de fraîcheur durable tout au long de la journée. Sa formule douce respecte la peau tout en aidant à neutraliser les odeurs, sans sels d’aluminium ni ingrédients controversés. Compact et pratique, il s’emporte facilement dans un sac de sport, un sac à main ou une trousse de voyage pour rester serein en toutes circonstances."
    );
    $deodorant->setImagePath('images/products/deodorant.png');
    $manager->persist($deodorant);

    $savon = new Product();
    $savon->setName('Savon Bio');
    $savon->setPrice(18.90);
    $savon->setShortDescription('Thé, Orange & Girofle');
    $savon->setLongDescription(
      "Ce savon bio mêle subtilement les notes de thé, d’orange et de girofle pour offrir une expérience sensorielle chaude et épicée. Sa formule douce nettoie la peau sans l’assécher, tout en laissant un parfum délicat après le rinçage. Idéal pour un usage quotidien, il remplace avantageusement les gels douche en flacon plastique et s’inscrit dans une démarche de soin plus naturelle et responsable."
    );
    $savon->setImagePath('images/products/savon.png');
    $manager->persist($savon);

    // On envoie tout en base
    $manager->flush();
  }
}
