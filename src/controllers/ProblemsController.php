<?php


namespace vloop\problems\controllers;

use vloop\entities\decorators\CachedEntities;
use vloop\entities\decorators\exceptions\HandledExceptionsOfEntities;
use vloop\entities\decorators\ResetKeysOnListEntities;
use vloop\entities\decorators\rest\jsonapi\JsonApiOfEntities;
use vloop\entities\yii2\I18nOfFieldsEntities;
use vloop\problems\entities\forms\criteria\CriteriaIDEntity;
use vloop\problems\entities\forms\criteria\CriteriaProblemsByDates;
use vloop\problems\entities\forms\criteria\CriteriaReportByProblemId;
use vloop\problems\entities\forms\inputed\AddProblemForm;
use vloop\problems\entities\forms\inputed\AddReport;
use vloop\problems\entities\forms\inputed\ChangeReportDescription;
use vloop\problems\entities\forms\inputed\ChangeStatusProblemForm;
use vloop\problems\entities\problem\decorators\ProblemsByCriteriaForm;
use vloop\problems\entities\problem\ProblemsSQL;
use vloop\problems\entities\report\decorators\ReportsByCriteriaForm;
use vloop\problems\entities\report\ReportsSQL;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class ProblemsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        Yii::$app->request->parsers = [
            'application/json' => 'yii\web\JsonParser',
        ];
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
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new I18nOfFieldsEntities(
                        new CachedEntities(
                            new ProblemsSQL()
                        )
                    )
                ),
                'problem'
            );
        return $problems->list();
    }


    public function actionProblem()
    {
        $problems =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ResetKeysOnListEntities(
                        new I18nOfFieldsEntities(
                            new ProblemsByCriteriaForm(
                                new CriteriaIDEntity('get')
                            )
                        )
                    )
                ),
                'problem'
            );
        return $problems
            ->entity(0)
            ->printYourself();
    }

    public function actionDeleteProblem()
    {
        VarDumper::dump(Yii::$app->request->post());
        $problems =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ResetKeysOnListEntities(
                        new I18nOfFieldsEntities(
                            new ProblemsByCriteriaForm(
                                new CriteriaIDEntity()
                            )
                        )
                    )
                ),
                'problem'
            );
        $problems
            ->entity(0)
            ->remove();
    }

    public function actionAddProblem()
    {
        $problems =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ProblemsSQL()
                ),
                'problem'
            );
        return $problems
            ->add(new AddProblemForm())
            ->printYourself();
    }

    public function actionUpdateProblem()
    {
        $problem = new HandledExceptionsOfEntities(
            new JsonApiOfEntities(
                new ResetKeysOnListEntities(
                    new ProblemsByCriteriaForm(
                        new CriteriaIDEntity('post')
                    ),
                ),
                'problem'
            )
        );
        return $problem
            ->entity(0)
            ->changeLineData(new AddProblemForm())
            ->printYourself();

    }


    public function actionChangeStatus()
    {

        $problems =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ResetKeysOnListEntities(
                        new ProblemsByCriteriaForm(
                            new CriteriaIDEntity()
                        )
                    )
                ),
                'problem'
            );
        return $problems
            ->entity(0)
            ->changeLineData(new ChangeStatusProblemForm())
            ->printYourself();
    }

    public function actionReports()
    {
        $reports =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ReportsSQL()
                ),
                'report'
            );
        return $reports->list();
    }

    public function actionAddReport()
    {
        $reports =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ReportsSQL()
                ),
                'report'
            );
        return $reports
            ->add(new AddReport())
            ->printYourself();
    }

    public function actionChangeReport()
    {
        $report =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new CachedEntities(
                        new ResetKeysOnListEntities(
                            new ReportsByCriteriaForm(
                                new ReportsSQL(),
                                new CriteriaIDEntity()
                            )
                        )
                    )
                ),
                'problem'
            );
        return $report
            ->entity(0)
            ->changeLineData(new ChangeReportDescription())
            ->printYourself();
    }

    public function actionProblemsByDate()
    {
        $problems =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new CachedEntities(
                        new ProblemsByCriteriaForm(
                            new CriteriaProblemsByDates()
                        )
                    )
                ),
                'problem'
            );
        return $problems->list();
    }

    public function actionReportByProblemId()
    {
        $reports =
            new JsonApiOfEntities(
                new HandledExceptionsOfEntities(
                    new ResetKeysOnListEntities(
                        new ReportsByCriteriaForm(
                            new ReportsSQL(),
                            new CriteriaReportByProblemId()
                        )
                    )
                ),
                'report'
            );
        return $reports
            ->entity(0)
            ->printYourself();
    }
}