<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

class AppExtension extends \Twig_Extension
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('year', array($this, 'yearFilter')),
            new \Twig_SimpleFilter('mileage', array($this, 'mileageFilter')),
            new \Twig_SimpleFilter('weight', array($this, 'weightFilter')),
            new \Twig_SimpleFilter('power', array($this, 'powerFilter')),
            new \Twig_SimpleFilter('wheelsDiameter', array($this, 'wheelsDiameterFilter')),
            new \Twig_SimpleFilter('engineSize', array($this, 'engineSizeFilter')),
            new \Twig_SimpleFilter('dayago', array($this, 'dayAgoFilter')),
            new \Twig_SimpleFilter('dateago', array($this, 'dateAgoFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ' ')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' €';
        return $price;
    }

    public function yearFilter($number)
    {
        return $number.' m.';
    }

    public function weightFilter($number)
    {
        return $number.' kg';
    }

    public function powerFilter($number)
    {
        return $number.' kW';
    }

    public function mileageFilter($number)
    {
        $mileage = number_format($number, 0, '.', ' ');
        $mileage = $mileage.' km';
        return $mileage;
    }

    public function wheelsDiameterFilter($number)
    {
        return 'R'.$number;
    }

    public function engineSizeFilter($number)
    {
        $engineSize = number_format($number/1000, 1, '.', ' ');
        return $engineSize.' l.';
    }

    public function dayAgoFilter($days)
    {
        $date = (new \DateTime)->setTimestamp(strtotime('-' . $days . 'days'));
        return $this->dateAgoFilter($date);
    }

    public function dateAgoFilter($date)
    {
        $now = new \DateTime();

        $diff = $now->diff($date);
        $weeks = floor($diff->d / 7);

        $result = $this->translator->trans('date.others.ago') . ' ';

        if ($diff->y) {
            $result .= $diff->y . ' ' . $this->translator->trans('date.short.year');
        } elseif ($diff->m) {
            $result .= $diff->m . ' ' . $this->translator->trans('date.short.month');
        } elseif ($weeks) {
            $result .= $weeks . ' ' . $this->translator->trans('date.short.week');
        } elseif ($diff->d) {
            $result .= $diff->d . ' ' . $this->translator->trans('date.short.day');
        } elseif ($diff->h) {
            if ($diff->h < 2 && $diff->i) {
                $result .= $diff->h . ' ' . $this->translator->trans('date.short.hour')
                    . ' ' . $diff->i . ' ' . $this->translator->trans('date.short.minute');
            } else {
                $result .= $diff->h . ' ' . $this->translator->trans('date.short.hour');
            }
        } elseif ($diff->i) {
            $result .= $diff->i . ' ' . $this->translator->trans('date.short.minute');
        } else {
            $result .= '1 ' . $this->translator->trans('date.short.minute');
        }
        return $result;
    }
}
