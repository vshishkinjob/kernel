<?php

namespace Kernel\Components\Method;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Kernel\Components\Exception\App\InvalidReflectionTypeException;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\Exception\File\UndefinedMimeTypeException;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\MethodNotFoundException;
use Kernel\Components\Exception\Validation\Base64ValidationException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Request\RoutineInterface;
use LogicException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;

readonly class MethodComponent implements MethodComponentInterface
{
    /**
     * @param Container $container
     */
    public function __construct(
        private ContainerInterface $container,
        //private KernelLoggerInterface $logger,
        private Validator $validator,
        private ValidationContext $context
    ) {
    }

    /**
     * @param RoutineInterface $request
     * @return mixed
     * @throws BadRequestException
     * @throws Base64ValidationException
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws InvalidReflectionTypeException
     * @throws MethodNotFoundException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws NotValidEntityException
     * @throws ReflectionException
     * @throws TypeCastException
     * @throws ValidationException
     * @throws UndefinedMimeTypeException
     */
    public function runMethodFromRequest(RoutineInterface $request): mixed
    {
        $method = $this->getMethod($request);
//        $timeStampBefore = microtime(true);
//        $timeStampAfter = microtime(true);
//        $executeTime = $timeStampAfter - $timeStampBefore;
//        $this->logger->profileMethod($request->getRequestMethodClassName(), $request->getMethodParams(), $executeTime);
        return $method->execute($this->getMethodDto($method, $request));
    }

	/**
	 * @param RoutineInterface $request
	 * @return ExecuteInterface
	 * @throws ContainerExceptionInterface
	 * @throws DependencyException
	 * @throws MethodNotFoundException
	 * @throws NotFoundException
	 * @throws NotFoundExceptionInterface
	 */
    public function getMethod(RoutineInterface $request): ExecuteInterface
    {
        $methodClassName = $request->getRequestMethodClassName();
        if (class_exists($methodClassName) && is_subclass_of($methodClassName, ExecuteInterface::class)) {
            return $this->getMethodByClassName($methodClassName);
        }
        throw new MethodNotFoundException();
    }

	/**
	 * @param class-string<ExecuteInterface> $className
	 * @return ExecuteInterface
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
    public function getMethodByClassName(string $className): ExecuteInterface
    {
        /**
         * @var ExecuteInterface $method
         */
        $method = $this->container->get($className);
        return $method;
    }

    /**
     * @param ExecuteInterface $method
     * @param RoutineInterface $request
     * @return AbstractDTO
     * @throws BadRequestException
     * @throws Base64ValidationException
     * @throws FileNotFoundException
     * @throws FilePermissionDeniedException
     * @throws IncorrectFileFormatException
     * @throws NotValidEntityException
     * @throws ReflectionException
     * @throws ValidationException
     * @throws InvalidReflectionTypeException
     * @throws TypeCastException
     * @throws UndefinedMimeTypeException
     */
    private function getMethodDto(ExecuteInterface $method, RoutineInterface $request): AbstractDTO
    {
        $dto = $method->getMethodDto();
        $dto->setValidator($this->validator, $this->context);
        return $dto->parseRequestToDto($request);
    }
}
