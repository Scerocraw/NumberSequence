<?php

class extender {

    private $input = [];

    private $distances = [];

    private $weightMap = [];

    private $factorOperation = [];

    /**
     * extender constructor.
     */
    public function __construct() {

    }

    /**
     * @param array $input
     * @param int $extendBy
     * @return array
     */
    public function proceed($input, $extendBy) {
        $this->input           = $input;
        $this->distances       = $this->getDistanceBetween($input);
        $this->weightMap       = $this->generateWeightMap($this->distances);
        $this->factorOperation = $this->getFactorOperation($this->weightMap);

        if (empty($this->factorOperation)) {
            $newMap = [];

            foreach ($this->distances as $distanceStep) {
                foreach ($distanceStep as $operation => $value) {
                    $newMap[$operation][] = $value;
                }
            }

            foreach ($newMap as $operation => $newInput) {
                $tempResult = $this->proceed($newInput, $extendBy);
                if (!empty($tempResult)) {
                    echo "<pre>";
                    $newExtension = $this->getExtension($this->factorOperation, $newInput, $extendBy);
                    $newOperation = $operation;
                    $newExtension = !empty($newExtension) ? $newExtension : $tempResult;
                }
            }

            if (!empty($newExtension) && !empty($newOperation)) {
                $lastInput = $input[count($input) - 1];

                foreach ($newExtension as $number) {
                    switch ($newOperation) {
                        case 'addition':
                            $result            = $lastInput + $number;
                            $tempExtension[]   = $result;
                            $lastInput         = $result;
                            break;
                        case 'subtraction':
                            $result            = $lastInput - $number;
                            $tempExtension[]   = $result;
                            $lastInput         = $result;
                            break;
                        case 'multiplication':
                            $result            = $lastInput * $number;
                            $tempExtension[]   = $result;
                            $lastInput         = $result;
                            break;
                        case 'division':
                            $result            = $lastInput / $number;
                            $tempExtension[]   = $result;
                            $lastInput         = $result;
                            break;
                    }
                }

                if (!empty($tempExtension)) {
                    return $tempExtension;
                }
            }
        }

        $extension = $this->getExtension($this->factorOperation, $input, $extendBy);

        return $extension;
    }

    /**
     * Calculates the extension of the next number
     * @param array $factorOperation
     * @param array $input
     * @param int $extendBy
     * @return array
     */
    private function getExtension($factorOperation, $input, $extendBy) {
        $extension = [];

        if (!empty($factorOperation)) {
            $lastInput = $input[count($input) - 1];
            for ($ii = 0; $ii < $extendBy; $ii++) {
                switch ($factorOperation['operation']) {
                    case 'addition':
                        $result            = $lastInput + $factorOperation['factor'];
                        $extension[]       = $result;
                        $lastInput         = $result;
                        break;
                    case 'subtraction':
                        $result            = $lastInput - $factorOperation['factor'];
                        $extension[]       = $result;
                        $lastInput         = $result;
                        break;
                    case 'multiplication':
                        $result            = $lastInput * $factorOperation['factor'];
                        $extension[]       = $result;
                        $lastInput         = $result;
                        break;
                    case 'division':
                        $result            = $lastInput / $factorOperation['factor'];
                        $extension[]       = $result;
                        $lastInput         = $result;
                        break;
                }
            }
        }

        return $extension;
    }

    /**
     * Check inside the weightMap if there is a only one occurring operation with factor
     * @param array $weightMap
     * @return array
     */
    private function getFactorOperation(array $weightMap) {
        $factorOperation = [];
        foreach ($weightMap as $operation => $possibleFactors) {
            if (count($possibleFactors) === 1 && count($this->input) > 2) {
                $factorOperation = ['operation' => $operation, 'factor' => array_keys($possibleFactors)[0] ];
            }
        }

        return $factorOperation;
    }

    /**
     * Generates the map where it's possible to call the distances in-between
     * @param array $distances
     * @return array
     */
    private function generateWeightMap($distances) {
        $weightMap = [];

        foreach ($distances as $distance) {
            foreach ($distance as $operation => $factor) {
                if (!isset($weightMap[$operation])) {
                    $weightMap[$operation] = [];
                }

                if (!isset($weightMap[$operation][(string)$factor])) {
                    $weightMap[$operation][(string)$factor] = 0;
                }

                $weightMap[$operation][(string)$factor] += 1;
            }
        }

        return $weightMap;
    }

    /**
     * Calculates distances for different operations between the input numbers
     * @param $input
     * @return array
     */
    private function getDistanceBetween($input) {
        $distances = [];

        foreach ($input as $key => $number) {
            if ($key === 0) {
                continue;
            }

            $distances[$key - 1] = [
                'addition'          => $input[$key - 1] + $number,
                'subtraction'       => $input[$key - 1] - $number,
                'multiplication'    => $input[$key - 1] * $number,
                'division'          => $input[$key - 1] / $number,
            ];
        }

        return $distances;
    }

}
