<?php


namespace vloop\problems\controllers;

use vloop\problems\entities\cache\CachedEntities;
use vloop\problems\entities\EntitiesWithResetIds;
use vloop\problems\entities\exceptions\NotValidatedFields;
use vloop\problems\entities\forms\criteria\CriteriaIDEntity;
use vloop\problems\entities\forms\criteria\CriteriaProblemsByDates;
use vloop\problems\entities\forms\inputed\AddProblemForm;
use vloop\problems\entities\forms\inputed\AddReport;
use vloop\problems\entities\forms\inputed\ChangeReportDescription;
use vloop\problems\entities\forms\inputed\ChangeStatusProblemForm;
use vloop\problems\entities\forms\inputed\InputsForChangeReport;
use vloop\problems\entities\problem\decorators\ProblemsByCriteriaForm;
use vloop\problems\entities\problem\decorators\ProblemsByDates;
use vloop\problems\entities\problem\ProblemsSQL;
use vloop\problems\entities\report\decorators\ReportsByCriteriaForm;
use vloop\problems\entities\report\ReportSQL;
use vloop\problems\entities\report\ReportsSQL;
use vloop\problems\entities\rest\JsonApiEntities;
use vloop\problems\entities\rest\RestEntity;
use vloop\problems\entities\rest\EntitiesWithExceptions;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class ProblemsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?'], //на время разработки
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionProblems()
    {
        $problems =
            new EntitiesWithExceptions(
                new JsonApiEntities(
                    new CachedEntities(
                        new ProblemsSQL()
                    ),
                    'problem'
                )
            );
        return $problems->list();
    }


    public function actionProblem()
    {
        $problems =
            new EntitiesWithExceptions(
                new JsonApiEntities(
                    new EntitiesWithResetIds(
                        new ProblemsByCriteriaForm(
                            new CriteriaIDEntity('get')
                        )
                    ),
                    'problem'
                )
            );
        return $problems
            ->entity(0)
            ->printYourself();
    }

    public function actionAddProblem()
    {
        $problems =
            new EntitiesWithExceptions(
                new JsonApiEntities(
                    new ProblemsSQL(),
                    'problem'
                )
            );
        return $problems
            ->add(new AddProblemForm())
            ->printYourself();
    }


    public function actionChangeStatus()
    {
        $problems =
            new EntitiesWithExceptions( //если поместить в середину, то программа не прерывается.
                new JsonApiEntities( //с полями data
                    new EntitiesWithResetIds(
                        new ProblemsByCriteriaForm(
                            new CriteriaIDEntity()
                        )
                    ),
                    'problem'
                )
            );
        return $problems
            ->entity(0)
            ->changeLineData(new ChangeStatusProblemForm())
            ->printYourself();
    }

    public function actionReports(){
        $reports =
            new EntitiesWithExceptions(
              new JsonApiEntities(
                  new ReportsSQL(),
                  'report'
              )
            );
        return $reports->list();
    }

    public function actionAddReport()
    {
        $reports = new EntitiesWithExceptions(
            new JsonApiEntities(
                new ReportsSQL(),
                'report'
            )
        );
        return $reports
            ->add(new AddReport())
            ->printYourself();
    }

    public function actionChangeReport()
    {
        $report =
            new EntitiesWithExceptions(
                new JsonApiEntities(
                    new EntitiesWithResetIds(
                        new CachedEntities(
                            new ReportsByCriteriaForm(
                                new ReportsSQL(),
                                new CriteriaIDEntity()
                            )
                        )
                    ),
                    'problem'
                )
            );
        return $report
            ->entity(0)
            ->changeLineData(new ChangeReportDescription())
            ->printYourself();
    }

    public function actionProblemsByDate()
    {
        $problems =
        new EntitiesWithExceptions(
            new JsonApiEntities(
                new CachedEntities(
                    new ProblemsByCriteriaForm(
                        new CriteriaProblemsByDates()
                    )
                ),
                'problem'
            )
        );
        return $problems->list();
    }
}