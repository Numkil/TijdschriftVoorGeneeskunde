<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Document;

class MediaController extends Controller{

    /**
     * @Route("/admin/upload/{userid}/{subscriptionid}", name="uploadDocument")
     */
    public function uploadAction(Request $request, $userid, $subscriptionid)
    {
        $saveDir = 'bundles/global/uploads/' . $userid . '/bill/' . $subscriptionid ;
        $dir = $this->_container->get('kernel')->getRootDir() .
            '/../web/' . $saveDir;

        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        if (!is_writable($dir)) {
            throw new \Exception(sprintf("%s is not writeable", $saveDir));
        }

        // Create db entity from uploaded file
        $dbFile = new File($file->getClientOriginalName(), $saveDir, $file->getMimeType());

        $this->_em->persist($dbFile);
        $this->_em->flush();

        $ext = pathinfo($dbFile->getName(), PATHINFO_EXTENSION); // Get extension from filename
        $dbFile->setName(sprintf('%s%d.%s', basename($dbFile->getName(), $ext), $dbFile->getId(), $ext));

        if ($file->move($dir, $dbFile->getName())) {
            $this->_em->flush();
        } else {
            throw new \Exception('File could not be moved.');
        }

        return $dbFile;
    }
}